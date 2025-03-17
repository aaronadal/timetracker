import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import TextInput from '../../../../src/ui/components/shared/TextInput.vue'

describe('TextInput', () => {
  it('renders properly', () => {
    const wrapper = mount(TextInput, {
      props: {
        name: 'username',
        modelValue: ''
      }
    })

    expect(wrapper.find('label').exists()).toBe(false)
    expect(wrapper.find('input').exists()).toBe(true)
    expect(wrapper.find('input').attributes('name')).toBe('username')
  })

  it('renders properly with label', () => {
    const wrapper = mount(TextInput, {
      props: {
        name: 'username',
        label: 'Username',
        modelValue: ''
      }
    })

    expect(wrapper.find('label').exists()).toBe(true)
    expect(wrapper.find('label').text()).toBe('Username')
    expect(wrapper.find('input').exists()).toBe(true)
    expect(wrapper.find('input').attributes('name')).toBe('username')
  })

  it('updates model value when input changes', async () => {
    const wrapper = mount(TextInput, {
      props: {
        name: 'username',
        modelValue: ''
      }
    })

    await wrapper.find('input').setValue('user.name')

    expect(wrapper.emitted()).toHaveProperty('update:modelValue')
    expect(wrapper.emitted('update:modelValue')?.[0]).toEqual(['user.name'])
  })

  it('reflects model value changes from parent', async () => {
    const wrapper = mount(TextInput, {
      props: {
        name: 'username',
        modelValue: 'initial'
      }
    })

    expect(wrapper.find('input').element.value).toBe('initial')

    await wrapper.setProps({
      modelValue: 'updated'
    })

    expect(wrapper.find('input').element.value).toBe('updated')
  })
})
