<script setup>
import { computed } from 'vue'
import sourceData from '@/data.json'
import ExperienceCard from '@/components/ExperienceCard.vue'
import GoBack from '@/components/GoBack.vue'

const props = defineProps({
  id: { type: Number, required: true }
})

const destination = computed(() =>
  sourceData.destinations.find((destination) => destination.id === props.id)
)
</script>

<template>
  <div>
    <section class="destination" v-if="destination">
      <h1>{{ destination.name }}</h1>
      <GoBack />
      <div class="destination-details">
        <img :src="`/images/${destination.image}`" :alt="destination.name" />
        <p>{{ destination.description }}</p>
      </div>
    </section>

    <section class="experiences">
      <h2>Top Experiences in {{ destination.name }}</h2>
      <div class="cards">
        <RouterLink
          v-for="experience in destination.experiences"
          :key="experience.slug"
          :to="{ name: 'experience.show', params: { experienceSlug: experience.slug } }"
        >
          <ExperienceCard :experience />
        </RouterLink>
      </div>

      <RouterView />
    </section>
  </div>
</template>
