<template>
  <div>
    <h1>Create book</h1>
    <form action="#" method="POST" @submit.prevent="addBook">
      <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" v-model="title">
      </div>

      <div class="form-group">
        <label for="title">Author</label>
        <input type="text" name="author" id="author" v-model="author">
      </div>

      <div class="form-group">
        <label for="title">Image</label>
        <input type="text" name="image" id="image" v-model="image">
      </div>

      <div class="form-group">
        <label for="title">Description</label>
        <input type="text" name="description" id="description" v-model="description">
      </div>

      <div class="form-group">
        <label for="title">Link</label>
        <input type="text" name="link" id="link" v-model="link">
      </div>

      <div class="form-group">
        <label><input type="checkbox" name="featured" v-model="featured">Featured</label>
      </div>

      <ApolloQuery :query="require('@/graphql/queries/Categories.graphql')">
        <template slot-scope="{ result: { data, loading }, isLoading }">
          <div v-if="isLoading">Loading...</div>
          <select v-else v-model="category">
            <option v-for="category of data.categories" :value="category.id" :key="category.id">
              {{category.name}}
            </option>
          </select>
        </template>
      </ApolloQuery>

      <div class="form-group">
        <button type="submit">Add book</button>
      </div>
    </form>
  </div>
</template>

<script>
import addBook from '@/graphql/mutations/AddBook.graphql'

export default {
  name: "AddBook",
  data() {
    return {
      title: '',
      author: '',
      image: '',
      description: '',
      link: '',
      featured: false,
      category: '1',
    }
  },
  methods: {
    addBook() {
      this.$apollo.mutate({
        mutation: addBook,
        variables: {
          title: this.title,
          author: this.author,
          image: this.image,
          link: this.link,
          description: this.description,
          featured: this.featured,
          category_id: Number(this.category)
        }
      }).then((data) => {
        console.log(data);
        this.$router.push('/');
      }).catch((error) => {
        console.error(error);
      })
    }
  }
}
</script>

<style scoped>
  .form-group {
    margin-bottom: 32px;
  }
  input[type="text"] {
    padding: 1rem;
  }
  button {
    padding: 16px;
    background: #42b983;
    color: white;
    border-radius: 5rem;
  }
</style>
