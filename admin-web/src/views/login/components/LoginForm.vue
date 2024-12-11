<template>
  <div class="login-form-wrapper">
    <div class="login-form-title">{{ config.loginTitle }}</div>
    <div class="login-form-sub-title">{{ config.loginDesc }}</div>
    <div class="login-form-error-msg text-12">{{ errorMessage }}</div>
    <a-form
      ref="loginForm"
      :model="form"
      class="login-form"
      layout="vertical"
      @submit="handleSubmit"
    >
      <a-form-item
        field="username"
        :rules="[{ required: true, message: $t('yong_hu_ming_bu_neng_wei') }]"
        :validate-trigger="['change', 'blur']"
        hide-label
      >
        <a-input v-model="form.username" :placeholder="$t('yong_hu_ming')">
          <template #prefix>
            <icon-user />
          </template>
        </a-input>
      </a-form-item>
      <a-form-item
        field="password"
        :rules="[{ required: true, message: $t('mi_ma_bu_neng_wei_kong') }]"
        :validate-trigger="['change', 'blur']"
        hide-label
      >
        <a-input-password v-model="form.password" :placeholder="$t('mi_ma')" allow-clear>
          <template #prefix>
            <icon-lock />
          </template>
        </a-input-password>
      </a-form-item>

      <a-form-item
        field="verification_code"
        :rules="[{ required: true, message: $t('yan_zheng_ma_bu_neng_wei') }]"
        :validate-trigger="['change', 'blur']"
        hide-label
        v-if="config.opebCaptcha"
      >
        <a-space>
          <a-input v-model="form.verification_code" :placeholder="$t('yan_zheng_ma')">
            <template #prefix>
              <icon-safe />
            </template>
          </a-input>
          <a-tooltip :content="$t('dian_ji_shua_xin_yan_zhe')">
            <img
              :src="codeUrl"
              @click="reloadCode"
              alt=""
              srcset=""
              class="w-full h-32px rounded-2px cursor-pointer"
            />
          </a-tooltip>
        </a-space>
      </a-form-item>
      <a-space :size="16" direction="vertical">
        <div class="login-form-password-actions">
          <a-checkbox checked="remember" v-model="form.remember">{{ $t('ji_zhu_wo') }}</a-checkbox>
        </div>
        <a-button type="primary" html-type="submit" long :loading="loading">
          {{ $t('deng_lu') }}
        </a-button>
      </a-space>
    </a-form>
  </div>
</template>

<script lang="ts" setup>
import type { ValidatedError } from '@arco-design/web-vue/es/form/interface'

const config = ref(window.AmisAdmin)

const userStore = useUserStore()

const codeUrl = ref(config.value.captchaUrl)

const reloadCode = () => {
  codeUrl.value = `${config.value.captchaUrl}?${Date.now()}`
}

const errorMessage = ref('')

const { form, loading, send } = useForm(
  (formData) => {
    return apiUserLogin({
      username: formData.username,
      password: formData.password,
      remember: formData.remember
    })
  },
  {
    initialForm: {
      username: '',
      password: '',
      verification_code: '',
      remember: true
    }
  }
)

const handleSubmit = async ({
  errors,
  values
}: {
  errors: Record<string, ValidatedError> | undefined
  values: Record<string, any>
}) => {
  if (errors) {
    return
  }
  errorMessage.value = ''
  const [err, res] = await to(send(values))
  if (err) {
    errorMessage.value = err.message
    return
  }
  Message.success(i18n.global.t('deng_lu_cheng_gong'))
  userStore.login(res)
  toRouter({ name: PAGES.home })
}
</script>

<style lang="less" scoped>
.login-form {
  &-wrapper {
    width: 320px;
  }

  &-title {
    color: var(--color-text-1);
    font-weight: 500;
    font-size: 24px;
    line-height: 32px;
  }

  &-sub-title {
    color: var(--color-text-3);
    font-size: 14px;
    line-height: 24px;
  }

  &-error-msg {
    height: 32px;
    color: rgb(var(--red-6));
    line-height: 32px;
  }

  &-password-actions {
    display: flex;
    justify-content: space-between;
  }

  &-register-btn {
    color: var(--color-text-3) !important;
  }
}
</style>
