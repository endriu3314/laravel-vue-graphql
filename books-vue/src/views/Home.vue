<template>
  <div class="home">
    <router-link to="/books/add">Add a book</router-link>
    <ApolloQuery :query="categoriesQuery">
      <template slot-scope="{ result: { data, loading }, isLoading }">
        <div v-if="isLoading">Loading...</div>
        <div v-else>
          <a href="#" class="link-margin" @click.prevent="selectCategory('all')">All</a>
          <a href="#" class="link-margin" @click.prevent="selectCategory('featured')">Featured</a>
          <a href="#" v-for="category of data.categories" :key="category.id" @click.prevent="selectCategory(category.id)" class="link-margin">
            {{category.id}} {{category.name}}
          </a>
        </div>
      </template>
    </ApolloQuery>

    <div v-if="selectedCategory === 'all'">
      <ApolloQuery :query="query">
        <template slot-scope="{ result: { data, loading }, isLoading }">
          <div v-if="isLoading">Loading...</div>
          <div v-else>
            <div v-for="book of data.books" :key="book.id">
              <router-link :to="`/books/${book.id}`">
                {{book.id}} {{book.title}}
              </router-link>
              <div>{{ book.author }}</div>
              <img :src="book.image" alt="cover image" />
            </div>
          </div>
        </template>
      </ApolloQuery>
    </div>

    <div v-else-if="selectedCategory === 'featured'">
      <ApolloQuery :query="query" :variables="{ featured: true }">
        <template slot-scope="{ result: { data, loading }, isLoading }">
          <div v-if="isLoading">Loading...</div>
          <div v-else>
            <div v-for="book in data.booksByFeatured" :key="book.id">
              <router-link :to="`/books/${book.id}`">
                {{book.id}} {{book.title}}
              </router-link>
              <div>{{ book.author }}</div>
              <img :src="book.image" alt="cover image" />
            </div>
          </div>
        </template>
      </ApolloQuery>
    </div>

    <div v-else>
      <ApolloQuery :query="categoryQuery" :variables="{ id: selectedCategory }">
        <template slot-scope="{ result: { data, loading }, isLoading }">
          <div v-if="isLoading">Loading...</div>
          <div v-else>
            <div v-for="book of data.category.books" :key="book.id">
              <router-link :to="`/books/${book.id}`">
                {{book.id}} {{book.title}}
              </router-link>
              <div>{{ book.author }}</div>
              <img :src="book.image" alt="cover image" />
            </div>
          </div>
        </template>
      </ApolloQuery>
    </div>
  </div>
</template>

<script>
import booksFeaturedQuery from '@/graphql/queries/BooksFeatured.graphql'
import categoriesQuery from '@/graphql/queries/Categories.graphql'
import categoryQuery from '@/graphql/queries/Category.graphql'
import booksQuery from '@/graphql/queries/Books.graphql'

export default {
  name: 'Home',
  components: {
  },
  data() {
    return {
      booksFeaturedQuery,
      categoriesQuery,
      categoryQuery,
      booksQuery,
      selectedCategory: 'all',
      query: booksQuery,
    }
  },
  methods: {
    selectCategory(category) {
      if (category === 'all') {
        this.query = booksQuery;
      } else if (category === 'featured') {
        this.query = booksFeaturedQuery;
      } else {
        this.query = categoryQuery
      }

      this.selectedCategory = category;
    }
  }
}
</script>

<style>
  .link-margin {
    margin-right: 24px;
  }
</style>
