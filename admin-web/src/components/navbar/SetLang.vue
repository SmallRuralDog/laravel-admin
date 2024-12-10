<template>
  <a-dropdown trigger="click">
    <a-button class="nav-btn" type="outline" :shape="'circle'">
      <template #icon>
        <icon-language />
      </template>
    </a-button>
    <template #content>
      <a-doption
        v-for="(item, key) in config.language.options"
        :key="key"
        :value="key"
        @click="handleSelect(key)"
      >
        <template #icon>
          <icon-check v-show="key === config.currentLanguage" />
        </template>
        {{ item }}
      </a-doption>
    </template>
  </a-dropdown>
</template>

<script setup lang="ts">
import type { Language } from '@/plugins/i18n'

const appStore = useAppStore()
const config = ref(window.AmisAdmin)

const handleSelect = (value: string) => {
  appStore.setLanguage(value as Language)
}
</script>
