import type { WorkEntry } from "../../domain/entity/work-entry.root";
import type { WorkEntryRepositoryInterface } from "../../domain/repository/work-entry.repository";

export class AllWorkEntriesByUserQuery {
  constructor(
    private readonly repo: WorkEntryRepositoryInterface,
  ) {}

  async run(user: string): Promise<WorkEntry[]> {
    return this.repo.allByUser(user);
  }
}
