import type {
  WorkEntryRepositoryInterface
} from "@/core/tracking/domain/repository/work-entry.repository.ts";
import type {WorkEntry} from "@/core/tracking/domain/entity/work-entry.root.ts";

export class OpenEntryCommand {
  constructor(
    private readonly repo: WorkEntryRepositoryInterface,
  ) {}

  async run(user: string, start: number): Promise<WorkEntry> {
    return this.repo.open(user, start);
  }
}
