import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import Edit from './edit';
import metadata from './block.json';
import './editor.scss';

registerBlockType(metadata.name, {
    edit: Edit,
    save: () => null, // Bloc rendu côté serveur
});
