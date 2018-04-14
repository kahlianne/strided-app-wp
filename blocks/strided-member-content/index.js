/**
 * Block dependencies
 */
import classnames from 'classnames';
import Inspector from './inspector';
import attributes from './attributes';
import './style.scss';

const { __ } = wp.i18n;
const {
    registerBlockType,
    RichText,
    InspectorControls,
} = wp.blocks;
const {
    Spinner,
    withAPIData,
} = wp.components;

/**
 * Register static block example block
 */
export default registerBlockType(
    'strided-app/strided-member-content',
    {
        title: 'Strided Member Content',
        description: 'Add the display for horses, arenas, and runs.',
        category: 'widgets',
        icon: 'star-filled',
        keywords: [
            'horse horses',
            'arena arenas',
            'run runs'
        ],
        attributes,
        getEditWrapperProps( attributes ) {
            const { blockAlignment } = attributes;
            if ( 'left' === blockAlignment || 'right' === blockAlignment || 'full' === blockAlignment ) {
                return { 'data-align': blockAlignment };
            }
        },
        edit: withAPIData( props => {
                return {
                    posts: '/wp/v2/' + props.attributes.radioControl + '?per_page=' + props.attributes.rangeControl
                };
            } )( props => {
                if ( ! props.posts.data ) {
                    return (
                        <p className={props.className} >
                            <Spinner />
                            { 'Loading Posts' }
                        </p>
                    );
                }
                if ( 0 === props.posts.data.length ) {
                    return [
                      props.isSelected && <Inspector { ...props } />,
                      <p>{ 'No Posts' }</p>
                    ];
                }
                return [
                    props.isSelected && <Inspector { ...props } />,
                    <ul className={ props.className }>
                        { props.posts.data.map( post => {
                            return (
                                <li>
                                    <a className={ props.className } href={ post.link }>
                                        { post.title.rendered }
                                    </a>
                                </li>
                            );
                        }) }
                    </ul>
                ];
            } ) // end withAPIData
        , // end edit
        save() {
            // Rendering in PHP
            return null;
        },
    },
);
