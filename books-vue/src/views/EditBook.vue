<template>
  <div>
    <h1>Edit Book</h1>
    <form action="#" method="POST" @submit.prevent="editBook">
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
        <button type="submit">Edit book</button>
      </div>
    </form>
  </div>
</template>

<script>
import updateBook from '@/graphql/mutations/UpdateBook.graphql'
import book from '@/graphql/queries/Book.graphql'

export default {
  name: "EditBook",
  data() {
    return {
      title: '',
      author: '',
      image: '',
      description: '',
      link: '',
      featured: false,
      category: '1',
      book: null
    }
  },
  apollo: {
    book: {
      query: book,
      variables () {
        if (this.$route && this.$route.params)
          return {
            id: this.$route.params.id
          }
      },
      result({ data }) {
        this.title = data.book.title;
        this.author = data.book.author;
        this.image = data.book.image;
        this.description = data.book.description;
        this.link = data.book.link;
        this.featured = data.book.featured;
        this.category = data.book.category.id;
      }
    }
  },
  methods: {
    editBook() {
      this.$apollo.mutate({
        mutation: updateBook,
        variables: {
          id: this.$route.params.id,
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
        this.$router.push(`/books/${this.$route.params.id}`);
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
