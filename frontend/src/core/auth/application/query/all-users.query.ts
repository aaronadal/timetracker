import type {UserRepositoryInterface} from "@/core/auth/domain/repository/user.repository.ts";
import type {User} from "@/core/auth/domain/entity/user.ts";

export class AllUsersQuery {
  constructor(
    private readonly repo: UserRepositoryInterface,
  ) {}

  async run(): Promise<User[]> {
    return this.repo.all();
  }
}
