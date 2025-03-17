import { describe, it, expect, vi } from 'vitest'
import { DeleteEntryCommand } from '../../../../../src/core/tracking/application/command/delete-entry.command'

describe('DeleteEntryCommand', () => {
  it('deletes a work entry through the repository', async () => {
    const userId = 'user-1'
    const entryId = 'entry-1'

    const mockRepo = {
      allByUser: vi.fn(),
      open: vi.fn(),
      close: vi.fn(),
      delete: vi.fn().mockResolvedValue(undefined),
    }

    const command = new DeleteEntryCommand(mockRepo)

    await command.run(userId, entryId)

    expect(mockRepo.delete).toHaveBeenCalledWith(userId, entryId)
  })
})
