import { describe, it, expect, vi } from 'vitest'
import { CloseEntryCommand } from '../../../../../src/core/tracking/application/command/close-entry.command'
import { TimestampProvider } from '../../../../../src/core/shared/domain/timestamp-provider'

describe('CloseEntryCommand', () => {
  const now = TimestampProvider.now();

  it('closes a work entry through the repository', async () => {
    const userId = 'user-1'

    const mockRepo = {
      allByUser: vi.fn(),
      open: vi.fn(),
      close: vi.fn().mockResolvedValue(undefined),
      delete: vi.fn(),
    }

    const command = new CloseEntryCommand(mockRepo)

    await command.run(userId, now)

    expect(mockRepo.close).toHaveBeenCalledExactlyOnceWith(userId, now)
  })
})
