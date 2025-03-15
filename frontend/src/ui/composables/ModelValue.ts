import { type MaybeRef, type ShallowRef, shallowRef, watch } from "vue";
import { useRef } from "./Ref";

type ModelValue<T> = MaybeRef<T>;
type EventEmitter<T, E extends string> = { (event: E, value: T): void };

export function useModelValue<T, E extends string>(
  modelValue: ModelValue<T>,
  emit: EventEmitter<T, E>,
  event: E,
): ShallowRef<T> {
  const modelValueRef = useRef(modelValue);
  const proxy = shallowRef<T>(modelValueRef.value);

  watch(proxy, (newValue) => emit(event, newValue));
  watch(modelValueRef, (newValue) => (proxy.value = newValue));

  return proxy;
}
