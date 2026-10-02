import { useClearQueryParam } from "@/hooks/useClearQueryParam";
import { Button } from "../ui/button";

function FilterClearBtn() {
  const { clearParamValue } = useClearQueryParam();
  return (
    <Button size="sm" variant="outline" onClick={clearParamValue}>
      CLEAR
    </Button>
  );
}

export default FilterClearBtn;
