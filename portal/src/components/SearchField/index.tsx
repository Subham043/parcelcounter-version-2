import { Search } from "lucide-react";
import {
    InputGroup,
    InputGroupAddon,
    InputGroupInput,
} from "@/components/ui/input-group";

type Props = {
    onChange?: React.ChangeEventHandler<HTMLInputElement> | undefined;
    placeholder?: string;
};

function SearchField({ onChange, placeholder = "Search..." }: Props) {
    return (
        <InputGroup className="max-w-full flex-1">
            <InputGroupInput placeholder={placeholder} onChange={onChange} />
            <InputGroupAddon>
                <Search />
            </InputGroupAddon>
        </InputGroup>
    );
}

export default SearchField;
