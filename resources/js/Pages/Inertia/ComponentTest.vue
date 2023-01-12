<script setup>
import { ref } from 'vue'
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';



const value = "Valueが渡されればそれを表示"

const modelValue = ref("モデルのデフォルト")

</script>

<template>
  <GuestLayout>
    スロットの内容はコンポーネントを使用する親側で設定<br>
    <InputLabel :value = value>
      valueが渡されなければこれを表示
    </InputLabel>
    <!-- 親コンポーネントに対するバインド -->
    <TextInput
      :modelValue = modelValue
      @update:modelValue = "e => modelValue = e">
    </TextInput>
    {{ modelValue }}
  </GuestLayout>
</template>