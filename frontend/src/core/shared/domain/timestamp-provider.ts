export class TimestampProvider {
  private static mock: number | null = null

  static now(): number {
    return TimestampProvider.mock || Math.floor(new Date().getTime() / 1000)
  }
}
