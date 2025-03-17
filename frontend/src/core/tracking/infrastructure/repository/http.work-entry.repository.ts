import type { WorkEntryRepositoryInterface } from '@/core/tracking/domain/repository/work-entry.repository.ts'
import type { ApiClient, ApiCreatedResponse } from '@/core/shared/domain/api/api-client.ts'
import { WorkEntry } from '@/core/tracking/domain/entity/work-entry.root.ts'
import { TimestampProvider } from '@/core/shared/domain/timestamp-provider.ts'

type ApiWorkEntry = {
  id: string
  user: string
  start: number
  end: number | null
  createdAt: number
  updatedAt: number
}

export class HttpWorkEntryRepository implements WorkEntryRepositoryInterface {
  constructor(private readonly apiClient: ApiClient) {}

  async allByUser(user: string): Promise<WorkEntry[]> {
    const response = await this.apiClient.request<ApiWorkEntry[]>(
      `/tracking/${user}/work-entries`,
      'get',
    )

    return response.map(
      (entry: ApiWorkEntry) =>
        new WorkEntry(
          entry.id,
          entry.user,
          entry.start,
          entry.end,
          entry.createdAt,
          entry.updatedAt,
        ),
    )
  }

  async open(user: string, start: number): Promise<WorkEntry> {
    const response = await this.apiClient.request<ApiCreatedResponse>(
      `/tracking/${user}/work-entries/open`,
      'post',
      {
        start,
      },
    )

    return new WorkEntry(
      response.id,
      user,
      start,
      null,
      TimestampProvider.now(),
      TimestampProvider.now(),
    )
  }

  async close(user: string, end: number): Promise<void> {
    await this.apiClient.request<ApiCreatedResponse>(
      `/tracking/${user}/work-entries/close`,
      'post',
      {
        end,
      },
    )
  }

  async delete(user: string, id: string): Promise<void> {
    await this.apiClient.request<ApiCreatedResponse>(
      `/tracking/${user}/work-entries/${id}`,
      'delete',
    )
  }
}
