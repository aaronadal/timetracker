import { describe, it, expect, vi } from 'vitest'
import { AllUsersQuery } from '../../../../../src/core/auth/application/query/all-users.query'
import { User } from '../../../../../src/core/auth/domain/entity/user'
import { TimestampProvider } from '../../../../../src/core/shared/domain/timestamp-provider'

describe('AllUsersQuery', () => {
  const now = TimestampProvider.now();

  it('should return all users from the repository', async () => {
    const users = [
      new User('user-1', 'User 1', now, now),
      new User('user-2', 'User 2', now, now)
    ]

    const mockRepo = {
      all: vi.fn().mockResolvedValue(users)
    }

    const query = new AllUsersQuery(mockRepo)

    const result = await query.run()

    expect(mockRepo.all).toHaveBeenCalledOnce()
    expect(result).toEqual(users)
  })
});
