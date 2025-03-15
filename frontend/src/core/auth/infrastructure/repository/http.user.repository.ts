import type {UserRepositoryInterface} from "@/core/auth/domain/repository/user.repository.ts";
import type {ApiClient} from "@/core/shared/domain/api/api-client.ts";
import type {ApiCreatedResponse} from "@/core/shared/infrastructure/api/http.api-client.ts";
import {User} from "@/core/auth/domain/entity/user.ts";
import {TimestampProvider} from "@/core/shared/domain/timestamp-provider.ts";

type ApiUser = {
  id: string;
  name: string;
  createdAt: number
  updatedAt: number
}

export class HttpUserRepository implements UserRepositoryInterface {
  constructor(
    private readonly apiClient: ApiClient,
  ) {
  }

  async all(): Promise<User[]> {
    const response = await this.apiClient.request<ApiUser[]>(
      '/auth/users',
      'get'
    );

    return response.map(
      (user: ApiUser) => new User(user.id, user.name, user.createdAt, user.updatedAt),
    );
  }

  async create(name: string): Promise<User> {
    const response = await this.apiClient.request<ApiCreatedResponse>(
      '/auth/sign-up',
      'post',
      {
        name,
      }
    );

    return new User(
      response.id,
      name,
      TimestampProvider.now(),
      TimestampProvider.now(),
    );
  }
}
