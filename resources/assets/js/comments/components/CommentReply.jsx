import React, {Component} from 'react';
import {bindActionCreators} from 'redux';
import {connect} from 'react-redux';

class CommentReply extends Component{

    render(){
        return(
            <li>
                <div className="comment-avatar"><a href={this.props.profileURL}><img src={this.props.imageURL} alt=""/></a></div>
                <div className="comment-box">
                    <div className="comment-head">
                        <h6 className="comment-name"><a href={this.props.profileURL}>{this.props.username}</a></h6>
                        <span style={{marginTop: 7}}>posted {this.props.createdAt}</span>
                    </div>
                    <div id="reply-content" className="comment-content">
                        {this.props.replyMessage}
                    </div>
                </div>
            </li>
        );
    }
}

export default CommentReply;

