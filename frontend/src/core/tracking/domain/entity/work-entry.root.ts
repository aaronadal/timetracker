import { AggregateRoot } from '../../../shared/domain/entity/aggregate-root'
import type { UserId } from '@/core/auth/domain/entity/user.ts'
import { TimestampProvider } from '@/core/shared/domain/timestamp-provider.ts'

export type WorkEntryId = string

export class WorkEntry extends AggregateRoot {
  constructor(
    private readonly _id: WorkEntryId,
    private readonly _user: UserId,
    private readonly _start: number,
    private _end: number | null,
    private readonly _createdAt: number,
    private _updatedAt: number,
  ) {
    super()
  }

  get id(): WorkEntryId {
    return this._id
  }

  get user(): UserId {
    return this._user
  }

  get start(): number {
    return this._start
  }

  get end(): number | null {
    return this._end
  }

  set end(end: number | null) {
    this._end = end
  }

  get createdAt(): number {
    return this._createdAt
  }

  get updatedAt(): number {
    return this._updatedAt
  }

  finish(end: number): void {
    if (this._end !== null) {
      throw new Error('Work entry already finished')
    }

    this._end = end
    this._updatedAt = TimestampProvider.now()
  }
}
