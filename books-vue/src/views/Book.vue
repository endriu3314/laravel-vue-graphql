<template>
  <div class="book">
    <ApolloQuery :query="require('@/graphql/queries/Book.graphql')" :variables="{ id: $route.params.id }">
      <template slot-scope="{ result: { data, loading }, isLoading }">
        <div v-if="isLoading">Loading...</div>
        <div v-else>
          <div>{{ data.book.title }}</div>
          <div>- {{ data.book.category.name }} -</div>
          <div>{{ data.book.author }}</div>

          <div>
            <router-link :to="`/books/${data.book.id}/edit`" href="#" class="link-margin">Edit</router-link>
            <a href="#" @click.prevent="deleteBook" class="link-margin">Delete</a>
          </div>
        </div>
      </template>
    </ApolloQuery>
  </div>
</template>

<script>
import deleteBook from '@/graphql/mutations/DeleteBook.graphql';

export default {
  name: "Book",
  methods: {
    deleteBook() {
      this.$apollo.mutate({
        mutation: deleteBook,
        variables: {
          id: this.$route.params.id
        }
      }).then(data => {
        console.log(data);
        this.$router.push('/')
      }).catch(err => {console.error(err)})
    }
  }
}
</script>

<style scoped>

</style>
