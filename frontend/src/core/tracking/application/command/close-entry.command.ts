import type { WorkEntryRepositoryInterface } from '@/core/tracking/domain/repository/work-entry.repository.ts'

export class CloseEntryCommand {
  constructor(private readonly repo: WorkEntryRepositoryInterface) {}

  async run(user: string, end: number): Promise<void> {
    return this.repo.close(user, end)
  }
}
