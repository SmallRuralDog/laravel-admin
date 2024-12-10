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
        :rules="[{ required: true, message: '用户名不能为空' }]"
        :validate-trigger="['change', 'blur']"
        hide-label
      >
        <a-input v-model="form.username" :placeholder="`用户名`">
          <template #prefix>
            <icon-user />
          </template>
        </a-input>
      </a-form-item>
      <a-form-item
        field="password"
        :rules="[{ required: true, message: `密码不能为空` }]"
        :validate-trigger="['change', 'blur']"
        hide-label
      >
        <a-input-password v-model="form.password" :placeholder="`密码`" allow-clear>
          <template #prefix>
            <icon-lock />
          </template>
        </a-input-password>
      </a-form-item>

      <a-form-item
        field="verification_code"
        :rules="[{ required: true, message: ` 验证码不能为空` }]"
        :validate-trigger="['change', 'blur']"
        hide-label
        v-if="config.opebCaptcha"
      >
        <a-space>
          <a-input v-model="form.verification_code" :placeholder="`验证码`">
            <template #prefix>
              <icon-safe />
            </template>
          </a-input>
          <a-tooltip content="点击刷新验证码">
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
          <a-checkbox checked="remember" v-model="form.remember">记住我</a-checkbox>
        </div>
        <a-button type="primary" html-type="submit" long :loading="loading"> 登录 </a-button>
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
      remember: false
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
  Message.success('登录成功')
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
