import { describe, it, expect, vi } from 'vitest'
import { OpenEntryCommand } from '../../../../../src/core/tracking/application/command/open-entry.command'
import { WorkEntry } from '../../../../../src/core/tracking/domain/entity/work-entry.root'
import { TimestampProvider } from '../../../../../src/core/shared/domain/timestamp-provider'

describe('OpenEntryCommand', () => {
  const now = TimestampProvider.now();

  it('opens a new work entry through the repository', async () => {
    const mockEntry = new WorkEntry('entry-1', 'user-1', now, null, now, now)

    const mockRepo = {
      allByUser: vi.fn(),
      open: vi.fn().mockResolvedValue(mockEntry),
      close: vi.fn(),
      delete: vi.fn(),
    }

    const command = new OpenEntryCommand(mockRepo)

    const result = await command.run(mockEntry.user, mockEntry.start)

    expect(mockRepo.open).toHaveBeenCalledExactlyOnceWith(mockEntry.user, mockEntry.start)
    expect(result).toBe(mockEntry)
  })
})
