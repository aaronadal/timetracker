import {describe, expect, it, vi} from "vitest";
import type {ApiClient} from "../../../../../src/core/shared/domain/api/api-client";
import {TimestampProvider} from "../../../../../src/core/shared/domain/timestamp-provider";
import {
  HttpWorkEntryRepository
} from "../../../../../src/core/tracking/infrastructure/repository/http.work-entry.repository";
import {WorkEntry} from "../../../../../src/core/tracking/domain/entity/work-entry.root";

describe('HttpWorkEntryRepository', () => {
  const now = TimestampProvider.now();

  it('should GET all the work entries from the backend', async () => {
    const user = 'user-1'
    const entries = [
      new WorkEntry('entry-1', user, now, now, now, now),
      new WorkEntry('entry-2', user, now, null, now, now),
    ];
    const apiEntries = entries.map((entry) => ({
      id: entry.id,
      user: entry.user,
      start: entry.start,
      end: entry.end,
      createdAt: entry.createdAt,
      updatedAt: entry.updatedAt,
    }))

    const apiClient: ApiClient = {
      request: vi.fn().mockResolvedValueOnce(apiEntries),
    };

    const repo = new HttpWorkEntryRepository(apiClient);
    const result = await repo.allByUser(user);

    expect(apiClient.request).toHaveBeenCalledExactlyOnceWith(
      `/tracking/${user}/work-entries`,
      'get',
    );
    expect(result).toEqual(entries);
  })

  it('should POST the OPEN request to the backend', async () => {
    const entry = new WorkEntry('entry-1', 'user-1', now, null, now, now);

    const apiClient: ApiClient = {
      request: vi.fn().mockResolvedValueOnce({ id: entry.id }),
    };

    const repo = new HttpWorkEntryRepository(apiClient);
    const result = await repo.open(entry.user, entry.start);

    expect(apiClient.request).toHaveBeenCalledExactlyOnceWith(
      `/tracking/${entry.user}/work-entries/open`,
      'post',
      {start: entry.start},
    );
    expect(result).toEqual(entry);
  })

  it('should POST the CLOSE request to the backend', async () => {
    const user = 'user-1';

    const apiClient: ApiClient = {
      request: vi.fn().mockResolvedValueOnce(undefined),
    };

    const repo = new HttpWorkEntryRepository(apiClient);
    await repo.close(user, now);

    expect(apiClient.request).toHaveBeenCalledExactlyOnceWith(
      `/tracking/${user}/work-entries/close`,
      'post',
      {end: now},
    );
  })

  it('should DELETE the entry in the backend', async () => {
    const user = 'user-1';
    const entry = 'entry-1';

    const apiClient: ApiClient = {
      request: vi.fn().mockResolvedValueOnce(undefined),
    };

    const repo = new HttpWorkEntryRepository(apiClient);
    await repo.delete(user, entry);

    expect(apiClient.request).toHaveBeenCalledExactlyOnceWith(
      `/tracking/${user}/work-entries/${entry}`,
      'delete',
    );
  })
})
