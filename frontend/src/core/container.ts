import {SignUpCommand} from "@/core/auth/application/command/sign-up.command.ts";
import {AllUsersQuery} from "@/core/auth/application/query/all-users.query.ts";
import type {UserRepositoryInterface} from "@/core/auth/domain/repository/user.repository.ts";
import {HttpUserRepository} from "@/core/auth/infrastructure/repository/http.user.repository.ts";
import {
  ReactiveCacheUserRepository
} from "@/core/auth/infrastructure/repository/reactive-cache.user.repository.ts";
import type {ApiClient} from "@/core/shared/domain/api/api-client.ts";
import {HttpApiClient} from "@/core/shared/infrastructure/api/http.api-client.ts";
import type {
  WorkEntryRepositoryInterface
} from "@/core/tracking/domain/repository/work-entry.repository.ts";
import {
  HttpWorkEntryRepository
} from "@/core/tracking/infrastructure/repository/http.work-entry.repository.ts";
import {
  ReactiveCacheWorkEntryRepository
} from "@/core/tracking/infrastructure/repository/reactive-cache.work-entry.repository.ts";
import {
  AllWorkEntriesByUserQuery
} from "./tracking/application/query/all-work-entries-by-user.query";
import {OpenEntryCommand} from "@/core/tracking/application/command/open-entry.command.ts";
import {CloseEntryCommand} from "@/core/tracking/application/command/close-entry.command.ts";

type Initializer<T> = () => T;

export type ServiceKey = {
  'Shared.Api.Client': ApiClient,

  'Auth.User.Command.SignUp': SignUpCommand,
  'Auth.User.Query.All': AllUsersQuery,
  'Auth.User.Repository': UserRepositoryInterface,

  'Tracking.WorkEntry.Command.OpenEntry': OpenEntryCommand,
  'Tracking.WorkEntry.Command.CloseEntry': CloseEntryCommand,
  'Tracking.WorkEntry.Query.AllByUser': AllWorkEntriesByUserQuery,
  'Tracking.WorkEntry.Repository': WorkEntryRepositoryInterface,
}

class Container {
  private readonly initializers = new Map<keyof ServiceKey, Initializer<any>>();
  private readonly instances = new Map<keyof ServiceKey, any>();

  bind<K extends keyof ServiceKey>(key: K, initializer: Initializer<ServiceKey[K]>): void {
    this.initializers.set(key, initializer);
  }

  unbind<K extends keyof ServiceKey>(key: K): void {
    this.initializers.delete(key);
    this.instances.delete(key);
  }

  get<K extends keyof ServiceKey>(key: K): ServiceKey[K] {
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

  c.bind(
    'Tracking.WorkEntry.Command.CloseEntry',
    () => new CloseEntryCommand(c.get('Tracking.WorkEntry.Repository')),
  );

  c.bind(
    'Tracking.WorkEntry.Command.OpenEntry',
    () => new OpenEntryCommand(c.get('Tracking.WorkEntry.Repository')),
  );

  c.bind(
    'Tracking.WorkEntry.Query.AllByUser',
    () => new AllWorkEntriesByUserQuery(c.get('Tracking.WorkEntry.Repository')),
  );

  c.bind(
    'Tracking.WorkEntry.Repository',
    () => new ReactiveCacheWorkEntryRepository(new HttpWorkEntryRepository(c.get('Shared.Api.Client'))),
  );

  return c;
}

export const container = initContainer();
