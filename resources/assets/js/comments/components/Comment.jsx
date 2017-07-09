import React, {Component} from 'react';

class Comment extends Component {
    render(){
        return(
            <div className="comment-main-level">
                <div className="comment-avatar"><a href={this.props.profileURL}><img src={this.props.imageURL} alt=""/></a></div>
                <div className="comment-box">
                    <div className="comment-head">
                        <h6 className="comment-name"><a href={this.props.profileURL}>{this.props.username}</a></h6>
                        <span style={{marginTop: 7}}>posted {this.props.createdAt}</span>
                    </div>
                    <div id="comment-content" className="comment-content">
                        {this.props.commentMessage}
                    </div>
                </div>
            </div>
        );
    }
}

export default Comment;

