import React, { Component } from 'react';
import CommentForm from '../components/CommentForm.jsx';
import Comment from '../components/Comment.jsx';
import CommentReply from '../components/CommentReply.jsx';
import {postComment} from '../actions';
import {bindActionCreators} from 'redux';
import {connect} from 'react-redux';
import ReplyForm from '../components/ReplyForm.jsx';

class App extends Component{

    constructor(props){
        super(props);
        this.state = this.props.store;
    }

    render(){
        console.log('store state from App render: ', this.props.store);
        return(
            <div>
                <CommentForm app={this} postCommentUrl={this.props.data.post_comment_url} />
                <div id="comments-list" className="comments-list">
                    <li>
                        {this.state.comments.map((comment, index) => {
                            return(
                            <span key={comment.id}>
                                <Comment profileURL={comment.profileURL} imageURL={comment.imageURL} username={comment.username} createdAt={comment.createdAt} commentMessage={comment.commentMessage}/>
                                <ul className="comments-list reply-list">
                                    {comment.replies.map((reply, index) => {
                                    return(
                                        <CommentReply key={reply.id} profileURL={reply.profileURL} imageURL={reply.imageURL} username={reply.username} createdAt={reply.createdAt} replyMessage={reply.replyMessage}/>
                                    );
                                    })}
                                    <ReplyForm postReplyURL={comment.comment_reply_link} key={comment.id} comment_id={comment.id} app={this} />
                                </ul>
                            </span>
                            );
                        })}

                    </li>
                </div>
            </div>);
    }
}

function mapDispatchToProps(dispatch){
    return bindActionCreators({postComment}, dispatch);
}

function mapStateToProps(state){
    return {
       store: state
    };
}

export default connect(mapStateToProps, mapDispatchToProps)(App);

