import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import store from './store/store.js';

import '@scss/main.scss';

import { MuiThemeProvider, createMuiTheme } from '@material-ui/core/styles';

const theme = createMuiTheme({
	palette: {
		primary: { main: '#3B88F7' },
		secondary: { main: '#8B8BF9' },
		// type: 'dark',
	},
	typography: {
		useNextVariants: true,
	},
	overrides: {
		MuiInputBase: {
			root: {
				// background: '#fff'
			}
		},
		MuiFilledInput: {
			root: {
				padding: '20px 13px 2px 13px',
			},
			inputSelect: {
				padding: '10px 27px 4px 13px',
			}
		},
		MuiTabs: {
			indicator: {
				background: '#fff'
			}
		}
	}
});
import { SnackbarProvider } from 'notistack';
import App from './containers/App';
import supressNotices from '@/forms/utils/notices';

KaliFormsObject.notices = supressNotices();
ReactDOM.render(
	<Provider store={store}>
		<MuiThemeProvider theme={theme}>
			<SnackbarProvider>
				<App />
			</SnackbarProvider>
		</MuiThemeProvider>
	</Provider>,
	document.getElementById('kaliforms-container')
);
