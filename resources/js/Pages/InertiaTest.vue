<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { ref } from 'vue'

const newTitle = ref("TITLE")
const newContent = ref("CONTENT") 


</script>

<template>
  Inertiaテストです。<br>
  <a href="/">aタグ</a><br>
  <!-- Link：vue-routerと同じく非同期処理となる -->
  <Link href="/">Linkタグ</Link><br>
  <!-- Laravel側のrouteに記述したルート名 -->
  <Link :href="route('inertia.index')">名前付きのルートIndex</Link><br>
  <Link :href="route('inertia.show', {id : 1})">名前付きのルートshow</Link><br>
  <Link href="/inertia/create">名前なしクリエイト</Link>

  <div class="mb-8"></div>
  <input type="text" name="newTitle" v-model="newTitle">{{  newTitle }}<br>
  <input type="text" name="newContent" v-model="newContent">{{ newContent }}<br>
  
  <Link as="button" method="post" :href="route('inertia.store')" 
    :data="{
      title: newTitle,
      content: newContent
    }">store</Link>

</template>