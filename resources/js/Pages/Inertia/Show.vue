<script setup>
import { Inertia } from '@inertiajs/inertia';

defineProps({
  blog:Object
})

const deleteConfirm = id => {
  // 第二引数でリクエストに伴う処理をInertiaが用意したイベントを使用して設定できる
  Inertia.delete(`/inertia/delete/${id}`, {
    onBefore: () => {
      confirm('本当に削除しますか？')
    }
  })
}
</script>

<template>
    <div>
      {{ blog.id }}<br>
      {{ blog.title }}<br>
      <button @click="deleteConfirm(blog.id)">削除</button>
    </div>
</template>