import { FolderX } from "lucide-react";
import {
    Empty,
    EmptyDescription,
    EmptyHeader,
    EmptyMedia,
    EmptyTitle,
} from "@/components/ui/empty";
import { memo } from "react";

type Props = {
    title: string;
    description: string;
};

function EmptyDataBlock({ title, description }: Props) {
    return (
        <Empty>
            <EmptyHeader className="gap-1">
                <EmptyMedia variant="icon">
                    <FolderX />
                </EmptyMedia>
                <EmptyTitle className="text-base">{title}</EmptyTitle>
                <EmptyDescription className="text-sm text-muted-foreground">
                    {description}
                </EmptyDescription>
            </EmptyHeader>
        </Empty>
    );
}

export default memo(EmptyDataBlock);
