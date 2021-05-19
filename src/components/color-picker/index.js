import './style.scss';
import getIcon from '../../utils/get-icon';

import {
	__,
} from '@wordpress/i18n';

import {
	Button,
	Tooltip,
	Popover,
	BaseControl,
	ColorPicker,
	TextControl,
	ColorPalette,
} from '@wordpress/components';

import {
	useState,
} from '@wordpress/element';

const GeneratePressColorPickerControl = ( props ) => {
	const [ isOpen, setOpen ] = useState( false );
	const [ colorKey, setColorKey ] = useState( false );

	const {
		value,
		onChange,
		alpha,
		choices,
	} = props;

	const toggleVisible = () => {
		setOpen( true );
	};

	const toggleClose = () => {
		setOpen( false );
	};

	let tooltip = __( 'Choose Color', 'generatepress' );

	if ( choices.tooltip ) {
		tooltip = choices.tooltip;
	}

	return (
		<div className="generate-color-picker-area">
			<div className="components-color-palette__item-wrapper components-circular-option-picker__option-wrapper components-color-palette__custom-color">
				{ ! isOpen &&
					<Tooltip text={ tooltip } position="top center">
						<Button
							aria-expanded={ isOpen }
							className="components-color-palette__item components-circular-option-picker__option"
							onClick={ toggleVisible }
							aria-label={ tooltip }
							style={ { color: value ? value : 'transparent' } }
						>
							<span className="components-color-palette__custom-color-gradient" />
						</Button>
					</Tooltip>
				}

				{ isOpen &&
					<Tooltip text={ tooltip } position="top center">
						<Button
							aria-expanded={ isOpen }
							className="components-color-palette__item components-circular-option-picker__option"
							onClick={ toggleClose }
							aria-label={ tooltip }
							style={ { color: value ? value : 'transparent' } }
						>
							<span className="components-color-palette__custom-color-gradient" />
						</Button>
					</Tooltip>
				}
			</div>

			{ isOpen &&
				<Popover
					position="bottom center"
					className="generate-component-color-picker"
					onClose={ toggleClose }
					focusOnMount="container"
				>
					<BaseControl key={ colorKey }>
						<ColorPicker
							key={ colorKey }
							color={ value ? value : '' }
							onChangeComplete={ ( color ) => {
								let colorString;

								if ( 'undefined' === typeof color.rgb || color.rgb.a === 1 ) {
									colorString = color.hex;
								} else {
									const { r, g, b, a } = color.rgb;
									colorString = `rgba(${ r }, ${ g }, ${ b }, ${ a })`;
								}

								onChange( colorString );
							} }
							disableAlpha={ ! alpha }
						/>

						<div className="generate-color-input-wrapper">
							<span className="generate-color-input--icon">{ getIcon( 'color' ) }</span>
							<TextControl
								id="generate-color-input-field"
								className="generate-color-input"
								type={ 'text' }
								value={ value || '' }
								onChange={ ( color ) => {
									onChange( color );
								} }
								onBlur={ () => {
									setColorKey( value );
								} }
							/>

							<Button
								isSmall
								isSecondary
								className="components-color-clear-color"
								onClick={ () => {
									const defaultValue = ( props.defaultValue ) ? props.defaultValue : '';

									wp.customize.control( props.customizerSetting.id ).setting.set( defaultValue );
									setColorKey( defaultValue );

									setTimeout( function() {
										document.querySelector( '.generate-color-input-wrapper input' ).focus();
									}, 10 );
								} }
							>
								{ __( 'Default', 'generatepress' ) }
							</Button>
						</div>
					</BaseControl>

					<BaseControl
						className="generate-component-color-picker-palette"
					>
						<ColorPalette
							colors={ generateCustomizerControls.palette }
							value={ value }
							onChange={ ( color ) => {
								onChange( color );
								setColorKey( color );
							} }
							disableCustomColors={ true }
							clearable={ false }
						/>
					</BaseControl>
				</Popover>
			}
		</div>
	);
};

export default GeneratePressColorPickerControl;