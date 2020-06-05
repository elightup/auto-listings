let editorSettings = _.extend( {}, wp.codeEditor.defaultSettings );
editorSettings.codemirror.theme = 'oceanic-next';
export const editorHTML = wp.codeEditor.initialize( 'als-post-content', editorSettings ).codemirror;

let cssSettings = _.extend( {}, wp.codeEditor.defaultSettings );
cssSettings.codemirror.mode = 'css';
cssSettings.codemirror.theme = 'oceanic-next';
export const editorCSS = wp.codeEditor.initialize( 'als-post-excerpt', cssSettings ).codemirror;

let jsSettings = _.extend( {}, wp.codeEditor.defaultSettings );
cssSettings.codemirror.mode = 'javascript';
cssSettings.codemirror.theme = 'oceanic-next';
export const editorJS = wp.codeEditor.initialize( 'als-post-content-filtered', jsSettings ).codemirror;