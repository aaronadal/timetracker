import { describe, it, expect, vi } from 'vitest'
import { SignUpCommand } from '../../../../../src/core/auth/application/command/sign-up.command'
import { User } from '../../../../../src/core/auth/domain/entity/user'
import { TimestampProvider } from '../../../../../src/core/shared/domain/timestamp-provider'

describe('SignUpCommand', () => {
  const now = TimestampProvider.now();

  it('creates a user through the repository', async () => {
    const mockUser = new User('user-1', 'User 1', now, now)

    const mockRepo = {
      create: vi.fn().mockResolvedValue(mockUser)
    }

    const command = new SignUpCommand(mockRepo)

    const result = await command.run(mockUser.name)

    expect(mockRepo.create).toHaveBeenCalledExactlyOnceWith(mockUser.name)
    expect(result).toBe(mockUser)
  })
})
