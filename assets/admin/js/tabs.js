import { editorHTML, editorCSS, editorJS } from './editor.js';

const tabLinks  = [...document.querySelectorAll( '.als-tab__link' )]
const tabPanels = [...document.querySelectorAll( '.als-tab__pane' )]

tabLinks.forEach( btn => btn.addEventListener( 'click', e => changeTab( e ) ) );

export const changeTab = ( e ) => {
	hide( [...tabLinks, ...tabPanels] );
	show( e.target, tabLinks );
	show( e.target, tabPanels );
}

const hide = ( array, className = 'is-active' ) => {
	array.forEach(
		el => el.classList.remove( className )
	)
}

const show = ( e, array, className = 'is-active' ) => {
	if ( e.classList.contains( 'button' ) ) {
		e.classList.add( className );
	}

	array.find( el => el.dataset.tab === e.dataset.tab ).classList.add( className );

	if ( 'template-editor' === e.dataset.tab ) {
		editorHTML.refresh();
		editorHTML.focus();
	}

	if ( 'css-editor' === e.dataset.tab ) {
		editorCSS.refresh();
		editorCSS.focus();
	}

	if ( 'js-editor' === e.dataset.tab ) {
		editorJS.refresh();
		editorJS.focus();
	}
}