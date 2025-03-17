import { describe, it, expect, beforeEach, afterEach, vi } from 'vitest'
import { TimestampProvider } from '../../../../src/core/shared/domain/timestamp-provider'

describe('TimestampProvider', () => {
  beforeEach(() => {
    vi.useFakeTimers()
    vi.setSystemTime(new Date(1742159415000))
  })

  afterEach(() => {
    vi.useRealTimers()
  })

  it('should return current timestamp in seconds', () => {
    const timestamp = TimestampProvider.now()
    
    expect(timestamp).toBe(1742159415)
  })
})
