export abstract class AggregateRoot {
    abstract get id(): string
    abstract get createdAt(): number
    abstract get updatedAt(): number
}
