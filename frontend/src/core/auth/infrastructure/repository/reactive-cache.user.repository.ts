import type { UserRepositoryInterface } from '@/core/auth/domain/repository/user.repository.ts'
import { User } from '@/core/auth/domain/entity/user.ts'
import { reactive, type Reactive } from 'vue'

export class ReactiveCacheUserRepository implements UserRepositoryInterface {
  private cache: Reactive<User[]> | undefined = undefined

  constructor(private readonly inner: UserRepositoryInterface) {}

  async all(): Promise<User[]> {
    if (this.cache === undefined) {
      this.cache = reactive(await this.inner.all())
    }

    return this.cache as User[]
  }

  async create(name: string): Promise<User> {
    const response = await this.inner.create(name)

    if (this.cache !== undefined) {
      this.cache.push(response)
    }

    return response
  }
}
