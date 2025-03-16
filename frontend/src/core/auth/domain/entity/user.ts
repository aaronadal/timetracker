import {AggregateRoot} from '../../../shared/domain/entity/aggregate-root'

export type UserId = string;

export class User extends AggregateRoot {
    constructor(
        private readonly _id: UserId,
        private readonly _name: string,
        private readonly _createdAt: number,
        private _updatedAt: number,
    ) {
        super()
    }

    get id(): UserId {
        return this._id
    }

    get name(): string {
        return this._name
    }

    get createdAt(): number {
        return this._createdAt
    }

    get updatedAt(): number {
        return this._updatedAt
    }
}
