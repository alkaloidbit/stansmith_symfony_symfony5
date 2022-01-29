import * as React from "react";
import PropTypes from 'prop-types';
import { useRecordContext } from 'react-admin';

const TextField = (props) => {
    const { source } = props;
    const record = useRecordContext(props);
    return <span>{record[source]}</span>;
}

TextField.propTypes = {
    label: PropTypes.string,
    record: PropTypes.object,
    source: PropTypes.string.isRequired,
};

export default TextField;
