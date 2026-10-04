import { Button } from "@/components/ui/button";
import { Spinner } from "@/components/ui/spinner";
import { FileDown } from "lucide-react";

function ExcelExportButton({
  onExport,
  loading,
}: {
  onExport: () => Promise<void>;
  loading: boolean;
}) {
  return (
    <Button onClick={onExport} disabled={loading} variant="secondary">
      {loading ? (
        <Spinner className="size-5" data-icon="inline-start" />
      ) : (
        <FileDown size={16} data-icon="inline-start" />
      )}
      {loading ? "Exporting..." : "Export"}
    </Button>
  );
}

export default ExcelExportButton;
