import React, { useState, useEffect } from 'react';
import AddableFormEmail from '../components/AddableFormEmail/AddableFormEmail';
import connect from 'react-redux/es/connect/connect';
import { bindActionCreators } from 'redux';
import * as StoreActions from '../store/actions';
import TextField from '@material-ui/core/TextField'
import Button from '@material-ui/core/Button'
import Grid from '@material-ui/core/Grid'
import ExpansionPanel from '@material-ui/core/ExpansionPanel';
import ExpansionPanelSummary from '@material-ui/core/ExpansionPanelSummary';
import ExpansionPanelDetails from '@material-ui/core/ExpansionPanelDetails';
import Typography from '@material-ui/core/Typography';
import ExpandMoreIcon from '@material-ui/icons/ExpandMore';
import { useDebounce } from 'use-debounce';
const mapStateToProps = state => {
	return {
		loading: state.PageLoading,
		formEmails: state.FormEmails
	};
};

const mapDispatchToProps = dispatch => {
	return bindActionCreators(StoreActions, dispatch);
};

const FormEmails = (props) => {
	// State
	const [emails, setEmails] = useState(props.formEmails);
	const [debouncedEmails] = useDebounce(emails, 400);

	useEffect(() => {
		props.addEmail(emails)
	}, [debouncedEmails])

	useEffect(() => {
		if (JSON.stringify(props.formEmails) !== JSON.stringify(emails)) {
			setEmails(props.formEmails);
		}
	}, [props.formEmails])

	/**
	 * Adds an email to the list
	 */
	const addEmail = () => {
		let newEmail = {
			fromName: '',
			fromEmail: '',
			toEmail: '',
			replyTo: '',
			fromEmail: '',
			ccEmail: '',
			bccEmail: '',
			emailSubject: `Email #${props.formEmails.length + 1}`,
			emailAttachment: '',
			emailBody: ''
		};
		setEmails([...emails, newEmail])
	}
	/**
	 * Removes an email from the list
	 *
	 * Uses sort of a hack because react doesnt update it well, we set emails to nothing and afterward to the given state
	 * @param {*} index
	 * @memberof FormEmails
	 */
	const removeEmail = (index) => {
		let newEmails = emails.filter((e, idx) => {
			return idx !== index;
		});
		setEmails([...newEmails]);
	}

	/**
	 * When child state changes, update this as well
	 *
	 * @param {*} state
	 * @param {*} idx
	 * @memberof FormEmails
	 */
	const childStateChanged = (state, idx) => {
		emails[idx] = state;
		setEmails([...emails]);
	}

	return (
		<div style={{ paddingTop: 16, paddingLeft: 32, paddingRight: 32 }}>
			{emails.map((e, idx) => {
				return (
					<ExpansionPanel key={idx}>
						<ExpansionPanelSummary expandIcon={<ExpandMoreIcon />}>
							<Typography variant="subtitle1">{e.emailSubject}</Typography>
						</ExpansionPanelSummary>
						<ExpansionPanelDetails>
							<div style={{ width: '100%' }}>
								<AddableFormEmail emailData={e} index={idx} onChange={state => childStateChanged(state, idx)} />
								<Button style={{ marginTop: 20 }} variant="contained" color="primary" onClick={() => removeEmail(idx)}>{KaliFormsObject.translations.formEmails.removeEmail}</Button>
							</div>
						</ExpansionPanelDetails>
					</ExpansionPanel>
				)
			})}

			<Grid container>
				<Grid item xs={12}>
					<TextField
						type="hidden"
						name={"kaliforms[emails]"}
						value={JSON.stringify(emails)} />
					<Button style={{ marginTop: 20 }} variant="contained" color="primary" onClick={() => addEmail()}>{KaliFormsObject.translations.formEmails.addEmail}</Button>
				</Grid>
			</Grid>
		</div>
	);
}

export default connect(mapStateToProps, mapDispatchToProps)(FormEmails);
