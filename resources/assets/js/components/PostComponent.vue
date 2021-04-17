<template>
  <div class="post-app">
    <h1>Posts</h1>

    <div id="posts-container" class="row">
      <div class="col-md-12">

        <table class="table table-responsive">
          <thead>
          <tr>
            <th>Title</th>
            <th>Posted By</th>
            <th>Author</th>
            <th class="text-center">Replies</th>
            <th></th>
          </tr>
          </thead>

          <tbody>
            <tr v-for="post in postsObject">
              <td>{{ post.title }}</td>
              <td>{{ post.user }}</td>
              <td>{{ post.posted_at }}</td>
              <td class="text-center">{{ post.no_comments }}</td>
              <td>
                <button class="btn btn-sm btn-primary" @click="view(post.id)">View</button>
              </td>
            </tr>
          </tbody>
        </table>

      </div>
    </div>

    <div id="comment-form-container" class="row hide">
      <h3>{{ selected_post.title}}</h3>
      <div class="col-md-12">
        <p class="bg-info post-wrapper">
          {{ selected_post.post }}
          <br><br>
          <small class="pull-right">Author: {{ selected_post.user }}</small>
          <small class="pull-left">Posted at {{ selected_post.posted_at }}</small>
          <span class="clearfix"></span>
        </p>
        <p>
          <button class="btn btn-link pull-right" @click="showCommentForm">Reply</button>
          <button class="btn btn-link pull-right" @click="closeCommentFormContainer">Close</button>
        </p>
      </div>
      
      <div class="clearfix"></div>

      <div id="comments-wrapper" v-if="selected_post.no_comments">
        <h3>Comments</h3>
        <div class="row comment-row" v-for="comment in selected_post.comments">
          <div class="col-md-12">
            <p>{{ comment.comment }}</p>
          </div>
          <div class="col-md-12">
            <button class="btn btn-link pull-right" @click="showCommentForm">Reply</button>
          </div>
        </div>
      </div>

      <div id="comment-form-wrapper" class="hide">
        <h3>Add Comment</h3>
        <div class="col-md-10">
          <input type="text" class="form-control" name="user" v-model="form.user" placeholder="Enter your name here..." />
          <textarea name="comment" cols="30" rows="10"
                    v-model="form.comment"
                    class="form-control"
                    placeholder="Enter your comment here...">
          </textarea>
          <span v-if="errors.comment" class="help-block text-danger">{{ errors.comment[0] }}</span>
        </div>
        <div class="col-md-2">
          <input type="hidden" name="parent_id" v-model="form.post_id" />
          <input type="hidden" name="user" v-model="form.user" />
          <button class="btn btn-primary btn-block" @click="onSubmit">Save</button>
          <button class="btn btn-warning btn-block" @click="cancelSubmit">Cancel</button>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      postsObject: null,
      selected_post: "",
      form: {
        parent_id: null,
        user: null,
        comment: null
      },
      errors: []
    }
  },
  created() {
    this.fetch();
  },
  methods: {
    fetch() {
      Vue.axios.get('/api/posts')
        .then((response) => {
          this.postsObject = response.data;
        })
        .catch((response) => {
          console.error(response);
        });
    },

    view(post_id) {
      Vue.axios.get(`/api/post/${post_id}`)
        .then((response) => {
          this.selected_post = response.data;
          this.form.parent_id = response.data.id;
        })
        .catch((response) => {
          console.error(response);
        })
        .finally(() => {
          $('#comment-form-container').removeClass('hide');
          $('#posts-container').addClass('hide');
        })
    },

    onSubmit() {
      Vue.axios
          .post('/api/comment', this.form)
          .then((response) => {
            if (response.data.success) {
              // this.$swal({
              //   type: 'success',
              //   title: 'Your comment has been posted!'
              // }).then( ({data}) => {
                $('#comment-form-wrapper').addClass('hide');
                this.view(response.data.parent_id);
              // });
            }
          })
          .catch((response) => {
            console.error(response);
          });
    },

    cancelSubmit() {
      $('#comment-form-wrapper').addClass('hide');
    },

    showCommentForm() {
      $('#comment-form-wrapper').removeClass('hide');
    },

    closeCommentFormContainer() {
      $('#comment-form-container').addClass('hide');
      $('#posts-container').removeClass('hide');

      this.fetch();
    },
  }
}
</script>

<style scoped>
 h1 {
   margin-bottom: 65px;
 }
 h3 {
   margin-bottom: 20px;
 }
 .post-wrapper {
   padding: 12px;
 }
 #comment-form-wrapper {
   margin-top: 20px;
 }
 input[type='text'] {
   margin-bottom: 10px;
 }
 .comment-row {
   padding: 10px;
   margin-bottom: 10px;
   background-color: #F0F0F0;
 }
</style>