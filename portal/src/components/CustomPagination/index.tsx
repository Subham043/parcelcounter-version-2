import { memo, useCallback, useMemo } from "react";
import {
    Pagination,
    PaginationContent,
    PaginationEllipsis,
    PaginationItem,
    PaginationLink,
    PaginationNext,
    PaginationPrevious,
} from "@/components/ui/pagination";
import { Field, FieldLabel } from "@/components/ui/field";
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";

function CustomPagination({
    itemsPerPage,
    currentPage,
    totalCount,
    changePerPage,
    changePage,
}: {
    itemsPerPage: number;
    currentPage: number;
    totalCount: number;
    changePerPage: (pageRange: number) => void;
    changePage: (pageNo: number) => void;
}) {
    const totalPages = useMemo(
        () => Math.ceil(totalCount / itemsPerPage),
        [totalCount, itemsPerPage],
    );

    const paginationItems = useMemo(() => {
        const pages: (number | "ellipsis")[] = [];

        if (totalPages <= 7) {
            // Show all pages
            for (let i = 1; i <= totalPages; i++) {
                pages.push(i);
            }
        } else {
            // Always show first page
            pages.push(1);

            if (currentPage > 4) {
                pages.push("ellipsis");
            }

            // Pages around current page
            const start = Math.max(2, currentPage - 1);
            const end = Math.min(totalPages - 1, currentPage + 1);

            for (let i = start; i <= end; i++) {
                pages.push(i);
            }

            if (currentPage < totalPages - 3) {
                pages.push("ellipsis");
            }

            // Always show last page
            pages.push(totalPages);
        }

        return pages;
    }, [currentPage, totalPages]);

    const onChangePerPage = useCallback(
        (value: string | null) => {
            changePerPage(value ? Number(value) : 5);
        },
        [changePerPage],
    );

    const onChangePage = useCallback(
        (
            e: React.MouseEvent<HTMLAnchorElement, MouseEvent>,
            pageNo: number,
        ) => {
            e.preventDefault();
            changePage(pageNo);
        },
        [changePage],
    );
    return (
        <div className="flex items-center justify-between gap-4 px-4 py-3">
            <Field orientation="horizontal" className="w-fit">
                <FieldLabel htmlFor="select-rows-per-page">
                    Rows per page
                </FieldLabel>
                <Select
                    value={itemsPerPage.toString()}
                    onValueChange={onChangePerPage}
                >
                    <SelectTrigger className="w-20" id="select-rows-per-page">
                        <SelectValue />
                    </SelectTrigger>
                    <SelectContent align="start">
                        <SelectGroup>
                            <SelectItem value="5">5</SelectItem>
                            <SelectItem value="10">10</SelectItem>
                            <SelectItem value="15">15</SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
            </Field>
            <Pagination className="mx-0 w-auto">
                <PaginationContent>
                    <PaginationItem>
                        <PaginationPrevious
                            onClick={(e) => {
                                if (currentPage > 1)
                                    onChangePage(e, currentPage - 1);
                            }}
                            className={
                                currentPage === 1
                                    ? "pointer-events-none opacity-50"
                                    : ""
                            }
                        />
                    </PaginationItem>

                    {paginationItems.map((item, index) => (
                        <PaginationItem key={`${item}-${index}`}>
                            {item === "ellipsis" ? (
                                <PaginationEllipsis />
                            ) : (
                                <PaginationLink
                                    isActive={item === currentPage}
                                    onClick={(e) => {
                                        e.preventDefault();
                                        onChangePage(e, item);
                                    }}
                                >
                                    {item}
                                </PaginationLink>
                            )}
                        </PaginationItem>
                    ))}

                    <PaginationItem>
                        <PaginationNext
                            onClick={(e) => {
                                if (currentPage < totalPages)
                                    onChangePage(e, currentPage + 1);
                            }}
                            className={
                                currentPage === totalPages
                                    ? "pointer-events-none opacity-50"
                                    : ""
                            }
                        />
                    </PaginationItem>
                </PaginationContent>
            </Pagination>
        </div>
    );
}

export default memo(CustomPagination);
