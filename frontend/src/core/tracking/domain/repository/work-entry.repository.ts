import type { WorkEntry } from '@/core/tracking/domain/entity/work-entry.root.ts'

export interface WorkEntryRepositoryInterface {
  allByUser(user: string): Promise<WorkEntry[]>
  open(user: string, start: number): Promise<WorkEntry>
  close(user: string, end: number): Promise<void>
  delete(user: string, id: string): Promise<void>
}
