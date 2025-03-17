import {describe, expect, it, vi} from "vitest";
import type {ApiClient} from "../../../../../src/core/shared/domain/api/api-client";
import {User} from "../../../../../src/core/auth/domain/entity/user";
import {TimestampProvider} from "../../../../../src/core/shared/domain/timestamp-provider";
import {
  HttpUserRepository
} from "../../../../../src/core/auth/infrastructure/repository/http.user.repository";

describe('HttpUserRepository', () => {
  const now = TimestampProvider.now();

  it('should GET all the users from the backend', async () => {
    const users = [
      new User('user-1', 'User 1', now, now),
    ];
    const apiUsers = users.map((user) => ({
      id: user.id,
      name: user.name,
      createdAt: user.createdAt,
      updatedAt: user.updatedAt
    }))

    const apiClient: ApiClient = {
      request: vi.fn().mockResolvedValueOnce(apiUsers),
    };

    const repo = new HttpUserRepository(apiClient);
    const result = await repo.all();

    expect(apiClient.request).toHaveBeenCalledExactlyOnceWith('/auth/users', 'get');
    expect(result).toEqual(users);
  })

  it('should POST the new user to the backend', async () => {
    const user = new User('user-1', 'User 1', now, now);

    const apiClient: ApiClient = {
      request: vi.fn().mockResolvedValueOnce({ id: user.id }),
    };

    const repo = new HttpUserRepository(apiClient);
    const result = await repo.create(user.name);

    expect(apiClient.request).toHaveBeenCalledExactlyOnceWith('/auth/sign-up', 'post', {name: user.name});
    expect(result).toEqual(user);
  })
})
