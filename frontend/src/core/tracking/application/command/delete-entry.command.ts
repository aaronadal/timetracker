import type { WorkEntryRepositoryInterface } from '@/core/tracking/domain/repository/work-entry.repository.ts'

export class DeleteEntryCommand {
  constructor(private readonly repo: WorkEntryRepositoryInterface) {}

  async run(user: string, id: string): Promise<void> {
    return this.repo.delete(user, id)
  }
}
