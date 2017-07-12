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

    renderCommentForm(){
        if(this.props.store.auth_guest == false){
            if(this.props.store.is_locked == false) {
                return (
                    <CommentForm app={this} postCommentUrl={this.props.data.post_comment_url}/>
                )
            }
        }
    }

    renderReplyForm(comment){
        if(this.props.store.auth_guest == false) {
            if (this.props.store.is_locked == false) {
                return (
                    <ReplyForm postReplyURL={comment.comment_reply_link} key={comment.id} comment_id={comment.id}
                               app={this}/>
                );
            }
        }
    }

    renderLocked(){
        if(this.props.store.is_locked == true){
            return(
                <span>
                    <i className="fa fa-lock" />
                    <b style={{fontSize: 24}}> LOCKED</b>
                </span>
            );
        }
    }

    render(){
        return(
            <div>
                {this.renderLocked()}
                {this.renderCommentForm()}
                <div id="comments-list" className="comments-list">
                    <li>
                        {this.state.comments.map((comment, index) => {
                            return(
                            <span key={comment.id}>
                                <Comment user_id={comment.user_id} app={this} profileURL={comment.profileURL} commentUpdateURL={comment.commentUpdateURL} imageURL={comment.imageURL} username={comment.username} createdAt={comment.createdAt} commentMessage={comment.commentMessage}/>
                                <ul className="comments-list reply-list">
                                    {comment.replies.map((reply, index) => {
                                    return(
                                        <CommentReply user_id={reply.user_id} app={this} updateReplyURL={reply.updateReplyURL} key={reply.id} profileURL={reply.profileURL} imageURL={reply.imageURL} username={reply.username} createdAt={reply.createdAt} replyMessage={reply.replyMessage}/>
                                    );
                                    })}
                                    {this.renderReplyForm(comment)}
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

