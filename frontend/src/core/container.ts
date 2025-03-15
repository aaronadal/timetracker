import {SignUpCommand} from "@/core/auth/application/command/sign-up.command.ts";
import {AllUsersQuery} from "@/core/auth/application/query/all-users.query.ts";
import type {UserRepositoryInterface} from "@/core/auth/domain/repository/user.repository.ts";
import {
  ReactiveCacheUserRepository
} from "@/core/auth/infrastructure/repository/reactive-cache.user.repository.ts";
import {HttpUserRepository} from "@/core/auth/infrastructure/repository/http.user.repository.ts";
import type {ApiClient} from "@/core/shared/domain/api/api-client.ts";
import {HttpApiClient} from "@/core/shared/infrastructure/api/http.api-client.ts";

type Initializer<T> = () => T;

export type ServiceKey = {
  'Shared.Api.Client': ApiClient,

  'Auth.User.Command.SignUp': SignUpCommand,
  'Auth.User.Query.All': AllUsersQuery,
  'Auth.User.Repository': UserRepositoryInterface,
}

class Container {
  private readonly initializers = new Map<keyof ServiceKey, Initializer<any>>();
  private readonly instances = new Map<keyof ServiceKey, any>();

  public bind<K extends keyof ServiceKey>(key: K, initializer: Initializer<ServiceKey[K]>): void {
    this.initializers.set(key, initializer);
  }

  public unbind<K extends keyof ServiceKey>(key: K): void {
    this.initializers.delete(key);
    this.instances.delete(key);
  }

  public get<K extends keyof ServiceKey>(key: K): ServiceKey[K] {
    let instance = this.instances.get(key);
    if (!instance) {
      const initializer = this.initializers.get(key);
      if (!initializer) {
        throw new Error(`Service ${key} not found`);
      }

      instance = initializer();
      this.instances.set(key, instance);
    }

    return instance;
  }
}

function initContainer(): Container {
  const c = new Container();

  c.bind(
    'Shared.Api.Client',
    () => new HttpApiClient(),
  );

  c.bind(
    'Auth.User.Command.SignUp',
    () => new SignUpCommand(c.get('Auth.User.Repository')),
  );

  c.bind(
    'Auth.User.Query.All',
    () => new AllUsersQuery(c.get('Auth.User.Repository')),
  );

  c.bind(
    'Auth.User.Repository',
    () => new ReactiveCacheUserRepository(new HttpUserRepository(c.get('Shared.Api.Client'))),
  );

  return c;
}

export const container = initContainer();
