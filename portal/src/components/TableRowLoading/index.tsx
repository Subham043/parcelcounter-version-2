import CustomLoading from "../CustomLoading";

type Props = {
    colSpan?: number | undefined;
};

function TableRowLoading({ colSpan }: Props) {
    return (
        <tr>
            <td className="px-4 py-6 text-center" colSpan={colSpan}>
                <CustomLoading className="size-6" />
            </td>
        </tr>
    );
}

export default TableRowLoading;
