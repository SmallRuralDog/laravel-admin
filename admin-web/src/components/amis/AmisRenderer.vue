<template>
  <div class="amis-main" ref="amisEL"></div>
</template>

<script setup lang="ts">
//@ts-ignore
const amis = window.amisRequire('amis/embed')
const amisEL = ref(null)

const props = defineProps<{
  amisJson: object
}>()

const router = useRouter()
const route = useRoute()

const amisScoped = ref(null)

const build = () => {
  amisScoped.value = amis.embed(
    amisEL.value,
    props.amisJson,
    {
      locale: window.AmisAdmin.currentLanguage
    },
    {
      jumpTo: (to: string) => {
        if (to == 'back()') {
          router.back()
          return
        }
        //检测 http://或者 https://
        if (to.indexOf('http://') == 0 || to.indexOf('https://') == 0) {
          //@ts-ignore
          window.location.href = to
          return
        }
        router.push(to)
      },
      updateLocation: (to: string, replace: boolean) => {
        //过滤 query 参数
        const queryArr = to.split('&').filter((item) => {
          return item.indexOf('search[') === -1
        })
        let query = queryArr.join('&')
        //判断是否？开头
        if (query.indexOf('?') !== 0) {
          query = '?' + query
        }
        const path = route.path + query
        if (replace) {
          router.replace(path)
        } else {
          router.push(path)
        }
      },
      affixOffsetTop: 48
    }
  )
}

onMounted(() => build())
onUnmounted(() => {
  // @ts-ignore
  amisScoped.value?.unmount()
})
</script>

<style lang="less">
.amis-main {
  position: relative;
  //height: calc(100vh - 147px);
}
.amis-scope {
  background-color: transparent;
  .cxd-Page {
    border-radius: 4px;
  }
}
</style>
