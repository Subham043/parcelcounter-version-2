import { Spinner } from "../ui/spinner";

type Props = {
    className?: string;
};

export default function CustomLoading({ className }: Props) {
    return (
        <div className="flex justify-center items-center">
            <Spinner className={className} />
        </div>
    );
}
