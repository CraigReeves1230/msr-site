import React, {Component} from 'react';
import {bindActionCreators} from 'redux';
import {updateComment} from '../actions';
import {connect} from 'react-redux';

class Comment extends Component {

    constructor(props){
        super(props);

        this.state = {
            editing: false,
            text: this.props.commentMessage
        }
    }

    updateComment(event, text, url){
        event.preventDefault();

        $.ajax({
            data: {message_content: text},
            url: url,
            type: 'POST',
            async: true,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            timeout: 30000,
            dataType: 'json'
        }).done((responsedata) => {
            this.props.updateComment(text, url, responsedata);
            this.props.app.setState(this.props.store);
            this.setState({editing: false});
        });
    }

    cancelUpdate(){
        this.setState({editing: false, text: this.props.commentMessage});
    }

    render_edit(){
        return(
            <div className="comment-main-level">
                <div className="comment-avatar"><a href={this.props.profileURL}><img src={this.props.imageURL} alt=""/></a></div>
                <div className="comment-box">
                    <div className="comment-head">
                        <h6 className="comment-name"><a href={this.props.profileURL}>{this.props.username}</a></h6>
                        <span style={{marginTop: 7}}>posted {this.props.createdAt}</span>
                    </div>
                    <form onSubmit={(event) => {this.updateComment(event, this.state.text, this.props.commentUpdateURL);}}>
                        <div id="comment-content" className="comment-content">
                            <textarea rows="7" onChange={(event) => this.setState({text: event.target.value})} className="form-control" value={this.state.text}/>
                        </div>
                        <span>
                            <button onClick={() => this.cancelUpdate()}
                                    style={{float: "right", marginBottom: 12, marginRight: 12}} value="CANCEL" type="submit" className="btn btn-danger btn-circle">CANCEL</button>
                            <input style={{float: "right", marginBottom: 12, marginRight: 12}} value="SAVE CHANGES" type="submit" className="btn btn-success btn-circle" />
                        </span>
                    </form>
                </div>
            </div>
        )
    }

    renderEditButton() {
        if (this.props.store.auth_guest == false) {
            if (this.props.store.is_locked == false) {
                if (this.props.store.auth_user.id == this.props.user_id) {
                    return (
                        <span><button onClick={() => this.setState({editing: true})} style={{marginLeft: 30}}
                                      className="btn btn-default btn-circle">EDIT</button></span>
                    );
                }
            }
        }
    }



    render_display(){
        return(
            <div className="comment-main-level">
                <div className="comment-avatar"><a href={this.props.profileURL}><img src={this.props.imageURL} alt=""/></a></div>
                <div className="comment-box">
                    <div className="comment-head">
                        <h6 className="comment-name"><a href={this.props.profileURL}>{this.props.username}</a></h6>
                        <span style={{marginTop: 7}}>posted {this.props.createdAt}</span>
                        {this.renderEditButton()}
                    </div>
                    <div id="comment-content" className="comment-content">
                        {this.props.commentMessage}
                    </div>
                </div>
            </div>
        )
    }

    render(){
        if(this.state.editing == true){
            return this.render_edit()
        } else {
            return this.render_display();
        }
    }
}

function mapStateToProps(store){
    return {store: store}
}

function mapDispatchToProps(dispatch){
    return bindActionCreators({updateComment},dispatch);
}

export default connect(mapStateToProps, mapDispatchToProps)(Comment);

