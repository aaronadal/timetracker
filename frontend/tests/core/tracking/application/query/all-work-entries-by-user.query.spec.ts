import { describe, it, expect, vi } from 'vitest'
import { AllWorkEntriesByUserQuery } from '../../../../../src/core/tracking/application/query/all-work-entries-by-user.query'
import { WorkEntry } from '../../../../../src/core/tracking/domain/entity/work-entry.root'
import { WorkEntryRepositoryInterface } from '../../../../../src/core/tracking/domain/repository/work-entry.repository'
import { TimestampProvider } from '../../../../../src/core/shared/domain/timestamp-provider'

describe('AllWorkEntriesByUserQuery', () => {
  const now = TimestampProvider.now();

  it('retrieves all work entries for a user through the repository', async () => {
    const userId = 'user-1'
    const mockEntries = [
      new WorkEntry('entry-1', userId, now, now, now, now),
      new WorkEntry('entry-2', userId, now, null, now, now)
    ]

    const mockRepo: WorkEntryRepositoryInterface = {
      allByUser: vi.fn().mockResolvedValue(mockEntries),
      open: vi.fn(),
      close: vi.fn(),
      delete: vi.fn(),
    }

    const query = new AllWorkEntriesByUserQuery(mockRepo)

    const result = await query.run(userId)

    expect(mockRepo.allByUser).toHaveBeenCalledWith(userId)
    expect(result).toBe(mockEntries)
    expect(result).toHaveLength(2)
    expect(result[0].id).toBe('entry-1')
    expect(result[1].id).toBe('entry-2')
  })
})
