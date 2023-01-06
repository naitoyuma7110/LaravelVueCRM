<script setup>
  import { Link } from '@inertiajs/inertia-vue3';



</script>

<template>
  テストです。<br>
  <a href="/">aタグ</a><br>
  <!-- Link：vue-routerと同じく非同期処理となる -->
  <Link href="/">Linkタグ</Link><br>
  <!-- Laravel側のrouteに記述したルート名 -->
  <Link :href="route('inertia.index')">名前付きのルートIndex</Link><br>
  <Link :href="route('inertia.show', {id : 1})">名前付きのルートshow</Link>

  <div class="mb-8"></div>
  <input type="text" name="newTitle" v-model="newTitle">
  <input type="text" name="newContent" v-model="newContetn">
  <Link as="button" :href="route('inertia.store')"></Link>>
</template>