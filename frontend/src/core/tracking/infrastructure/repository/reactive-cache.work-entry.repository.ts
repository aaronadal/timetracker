import { reactive, type Reactive } from "vue";
import type {
  WorkEntryRepositoryInterface
} from "@/core/tracking/domain/repository/work-entry.repository.ts";
import type {WorkEntry} from "@/core/tracking/domain/entity/work-entry.root.ts";

export class ReactiveCacheWorkEntryRepository implements WorkEntryRepositoryInterface {
  private user: string | undefined = undefined;
  private cache: Reactive<WorkEntry[]> | undefined = undefined;

  constructor(
    private readonly inner: WorkEntryRepositoryInterface,
  ) {
  }

  async allByUser(user: string): Promise<WorkEntry[]> {
    if(this.user === user || this.cache !== undefined) {
      return this.cache as WorkEntry[];
    }

    this.user = user
    this.cache = reactive([]);

    const result = await this.inner.allByUser(user);
    for (const entry of result) {
      this.cache.push(entry);
    }

    return this.cache as WorkEntry[];
  }

  async open(user: string, start: number): Promise<WorkEntry> {
    const entry = await this.inner.open(user, start);
    if(user === this.user && this.cache !== undefined) {
      this.cache.push(entry);
    }

    return entry;
  }

  async close(user: string, end: number): Promise<void> {
    await this.inner.close(user, end);

    const open = this.openEntry(user);
    if(open === undefined) {
      return
    }

    open.end = end;
  }

  async delete(user: string, id: string): Promise<void> {
    await this.inner.delete(user, id);

    if (user === this.user && this.cache !== undefined) {
      const index = this.cache.findIndex((entry) => entry.id === id);
      if (index !== -1) {
        this.cache.splice(index, 1);
      }
    }
  }

  private openEntry(user: string): WorkEntry | undefined {
    if(user !== this.user || this.cache === undefined) {
      return undefined;
    }

    return this.cache.find((entry) => entry.end === null) as WorkEntry | undefined;
  }
}
