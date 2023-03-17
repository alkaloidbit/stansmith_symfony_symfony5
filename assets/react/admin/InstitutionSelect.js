import React, { Component } from "react";
import MenuItem from "@material-ui/core/MenuItem";
import Select from "@material-ui/core/Select";
import { withStyles } from '@material-ui/core/styles';
import MuiThemeProvider from "@material-ui/core/styles/MuiThemeProvider";
import { InputLabel, FormControl } from "@material-ui/core";

const styles = theme => ({
    fullWidth: {
        width: "100%"
    }
});

class InstitutionSelect extends Component {
    constructor(props) {
        super(props);
        this.state = {
            selectOptions: [
                {
                    value: "blablabla",
                    id: "1"
                },
            ],
            selectedValue: "",
        };
    }

    renderSelectOptions = () => {
        return this.state.selectOptions.map((option, i) => (
            <MenuItem key={option.id} value={option.id}>
                {option.value}
            </MenuItem>
        ));
    };

    handleChange = event => {
        this.setState({ selectedValue: event.target.value });
    };

    render() {
        const { classes } = this.props;

        return (
            <MuiThemeProvider>
                <FormControl className={classes.fullWidth}>
                    <InputLabel>Institution</InputLabel>
                    <Select value={this.state.selectedValue} onChange={this.handleChange} >
                        {this.renderSelectOptions()}
                    </Select>
                </FormControl>
            </MuiThemeProvider>
        );
    }
}

export default withStyles(styles)(InstitutionSelect);
