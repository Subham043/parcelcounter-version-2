import React, { useCallback, type KeyboardEventHandler } from "react";

import CreatableSelect from "react-select/creatable";

const components = {
  DropdownIndicator: null,
};

interface Option {
  readonly label: string;
  readonly value: string;
}

const createOption = (label: string): Option => ({
  label,
  value: label,
});

type propsType = {
  value: string[];
  onChange: (value: string[]) => void;
  placeholder?: string;
  disabled?: boolean;
};

export default function TagInput({
  value,
  onChange,
  placeholder = "Type something and press enter...",
  disabled,
}: propsType) {
  const [inputValue, setInputValue] = React.useState("");

  const handleKeyDown: KeyboardEventHandler = useCallback(
    (event) => {
      if (!inputValue) return;
      switch (event.key) {
        case "Enter":
        case "Tab":
          onChange([...value, inputValue]);
          setInputValue("");
          event.preventDefault();
      }
    },
    [value, inputValue, onChange],
  );

  return (
    <CreatableSelect
      components={components}
      inputValue={inputValue}
      isClearable
      isMulti
      menuIsOpen={false}
      onChange={(newValue) => onChange(newValue.map((item) => item.value))}
      onInputChange={(newValue) => setInputValue(newValue)}
      onKeyDown={handleKeyDown}
      placeholder={placeholder}
      value={value.map((item) => createOption(item))}
      isDisabled={disabled}
    />
  );
}
