import { ExternalLink } from "lucide-react";

function SwitchApps() {
    return (
        <button className="hidden md:flex items-center gap-1.5 px-3 py-1.5 text-sm text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
            Switch Apps
            <ExternalLink size={13} />
        </button>
    );
}

export default SwitchApps;
